// suscripcion.js

// Reemplaza 'tu_public_key' con tu clave pública proporcionada por Flow
const flow = new Flow("640370F5-956D-4BDF-9DA4-871A5523LEC5");

// Lógica para manejar la interacción con Flow cuando el usuario selecciona el plan
document.addEventListener("DOMContentLoaded", function () {
    const planSelector = document.getElementById("plan");
    let selectedPlan = planSelector.value;

    // Crear el botón de Flow dependiendo del plan seleccionado
    createFlowButton(selectedPlan);

    planSelector.addEventListener("change", function () {
        selectedPlan = planSelector.value;
        createFlowButton(selectedPlan); // Actualiza el botón cuando el plan cambie
    });

    // Función para crear el botón de Flow con el plan seleccionado
    function createFlowButton(plan) {
        flow.create(plan, {
            container: '#flow-button-container',
            style: {
                size: 'large',
                color: 'blue',
                shape: 'rect'
            },
            onReady: function(paymentRequest) {
                console.log('El botón de Flow está listo');
            },
            onToken: function(token, paymentData) {
                console.log('Token recibido:', token);
                document.getElementById("submitBtn").style.display = 'block'; // Muestra el botón de confirmación

                // Agrega el token al formulario para enviarlo al servidor
                let tokenInput = document.createElement('input');
                tokenInput.setAttribute('type', 'hidden');
                tokenInput.setAttribute('name', 'payment_token');
                tokenInput.setAttribute('value', token);
                document.getElementById('subscriptionForm').appendChild(tokenInput);
            },
            onError: function(error) {
                console.error('Error en el pago:', error);
            }
        });
    }
});