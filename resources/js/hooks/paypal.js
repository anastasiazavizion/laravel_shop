import {useToast} from "vue-toastification";
import {computed, watch} from "vue";
import {useStore} from "vuex";
import {useRouter} from "vue-router";

const paypalFunction = (form, emptyFields, errors) => {

    const store = useStore();
    const toast= useToast();
    const router = useRouter();

    const cartItems = computed(()=>{
        return store.getters['cart/cartItems']
    })

    form.value.cartItems = cartItems.value;

    function hasEmptyFields() {
        return Object.values(form.value).some(value => {
            if (Array.isArray(value)) {
                return false; // Skip array values
            }
            return !value || value.trim() === '';
        });
    }

    function setEmptyFields(){
        emptyFields.value = [];
        Object.keys(form.value).forEach(key => {
            if (Array.isArray(form.value[key])) {
                return false; // Skip array values
            }
            if(!form.value[key] || form.value[key].trim() === ''){
                emptyFields.value.push(key);
            }
        });
    }

    paypal.Buttons({
        onInit(data, actions){
            actions.disable();
            watch(form, () => {
                setEmptyFields();
                if (!hasEmptyFields()) {
                    actions.enable();
                } else {
                    actions.disable();
                }
            }, { deep: true });
        },

        onClick() {
            if(hasEmptyFields()){
                setEmptyFields();
                toast.error('Please fill all fields', {
                    timeout: 3000
                });
            }
        },

        // Call your server to set up the transaction
        createOrder: function (data, actions) {
            errors.value = {};
            return axios.post(route('v1.paypal.order.create'), form.value).then(function (res) {
                return res.data.vendor_order_id;
            }).catch(function (error) {
                if(error.response.status === 422){
                    errors.value = error.response.data.errors;
                }
            });
        },

        // Call your server to finalize the transaction
        onApprove: function (data, actions) {
            return axios.post(route('v1.paypal.order.capture', data.orderID))
                .then(function (res) {
                 toast.success('Order was created!', {
                        onClose: () => {
                            store.dispatch('cart/clearCart');
                            router.push('orders/'+res.data.vendor_order_id+'/thank-you');
                        }
                    });
                }).catch(function (orderData) {
                    if(orderData.response.status === 500 && orderData.response.statusText === 'Internal Server Error'){
                        errors.value.server = 'Problems on server, please try later'
                    }
            });
        }
    }).render('#paypal-button-container');
}
export default paypalFunction;
