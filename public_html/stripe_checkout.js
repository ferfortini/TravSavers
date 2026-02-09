// This is your test publishable API key.
const stripe = Stripe("pk_live_51OAdc7DV4DyT7rqbby98ICRd84RPzGfFjPKoeD4zPHBHX0jplweWYfgLf5vSGQ2xushrlHByEztWfkN3bDoHmOvF00Nd8VXwjo");

initialize();

// Create a Checkout Session as soon as the page loads
async function initialize() {
  const response = await fetch("stripe_checkout.php", {
    method: "POST",
  });

  const { clientSecret } = await response.json();

  const checkout = await stripe.initEmbeddedCheckout({
    clientSecret,
  });

  // Mount Checkout
  checkout.mount('#checkout');
}