const loginEmailBtn = document.querySelector(".login-with-email");
const loginForm = document.querySelector(".login-form");

loginEmailBtn.addEventListener("click", () => {
  loginForm.style.display = "block";
  loginEmailBtn.style.display = "none";
});

const singupEmailBtn = document.querySelector(".login-with-email");
const signupForm = document.querySelector(".signup-form");

singupEmailBtn.addEventListener("click", () => {
    signupForm.style.display = "block";
    singupEmailBtn.style.display = "none";
});

paypal.Buttons({
  createOrder: function(data, actions) {
      return actions.order.create({
          purchase_units: [{
              amount: {
                  value: '1000' // Replace with the price you want
              }
          }]
      });
  },
  onApprove: function(data, actions) {
      return actions.order.capture().then(function(details) {
          alert('Transaction completed by ' + details.payer.name.given_name);
          // You can also redirect or perform actions here after a successful payment
      });
  }
}).render('#paypal-button-container');