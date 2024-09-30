import loadGoogleMapsApi from 'load-google-maps-api';
export default function initializeAutocomplete(inputId, form) {
    loadGoogleMapsApi({
        key: import.meta.env.VITE_GOOGLE_API_KEY,
        libraries: ['places']
    }).then(function () {
        const input = document.getElementById(inputId);
        let autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.addListener("place_changed", onPlaceChange);
        function onPlaceChange() {
            const place = autocomplete.getPlace();
            const addressComponents = place.address_components;
            let street = '';
            let streetNumber= '';
            let administrativeAreaLevel1= '';
            let city= '';

            for (let component of addressComponents) {
                switch (component.types[0]) {
                    case "locality": // City
                        city = component.long_name;
                        break;
                    case "administrative_area_level_1": // City
                        administrativeAreaLevel1 = component.long_name;
                        break;
                    case "postal_code":
                        form.value.postcode = component.long_name;
                        break;
                    case "country":
                        form.value.country = component.long_name;
                        break;
                    case "route":
                        street = component.long_name;
                        break;
                    case "street_number":
                        streetNumber = component.long_name;
                        break;
                }
            }

            form.value.address = (street+' '+streetNumber).trim();
            form.value.city = (city + ' '+administrativeAreaLevel1).trim();
        }
    }).catch(function (error) {
        console.error(error)
    })
}
