import {useToast} from "vue-toastification";
import {watch} from "vue";

const paypalFunction = (form, emptyFields) => {
    function hasEmptyFields() {
        return Object.values(form.value).some(value => !value || value.trim() === '');
    }

    function setEmptyFields(){
        emptyFields.value = [];
        Object.keys(form.value).forEach(key => {
            if(!form.value[key] || form.value[key].trim() === ''){
                emptyFields.value.push(key);
            }
        });
    }

    watch(form, () => {
        setEmptyFields();
    }, { deep: true });

    paypal.Buttons({
        onInit(data, actions){
            actions.disable();
            if(!hasEmptyFields()){
                actions.enable();
            }
        },

        // onClick is called when the button is selected
        onClick() {
            if(hasEmptyFields()){
                setEmptyFields();
                const toast= useToast();
                toast.error('Please fill all fields', {
                    timeout: 3000
                });
            }
        },

        // Call your server to set up the transaction
        createOrder: function (data, actions) {
            return axios.post('paypal/order', form.value).then(function (res) {
                return res.data.vendor_order_id;
            }).catch(function (error) {
                console.log(error);
            });
        },


        // Call your server to finalize the transaction
        onApprove: function (data, actions) {
            return axios.post('paypal/order/' + data.vendor_order_id + '/capture')
                .then(function (res) {
                console.log(res);
            }).catch(function (orderData) {
                // Three cases to handle:
                //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                //   (2) Other non-recoverable errors -> Show a failure message
                //   (3) Successful transaction -> Show confirmation or thank you

                // This example reads a v2/checkout/orders capture response, propagated from the server
                // You could use a different API or structure for your 'orderData'
                    const errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                    if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                    return actions.restart(); // Recoverable state, per:
                    // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                }

                if (errorDetail) {
                    let msg = 'Sorry, your transaction could not be processed.';
                    if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                    if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                    return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                }

                // Successful capture! For demo purposes:
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                // Replace the above to show a success message within this page, e.g.
                // const element = document.getElementById('paypal-button-container');
                // element.innerHTML = '';
                // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                // Or go to another URL:  actions.redirect('thank_you.html');
            });
        }

    }).render('#paypal-button-container');
}

export default paypalFunction;
