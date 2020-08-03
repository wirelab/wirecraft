import 'core-js/stable';
import 'regenerator-runtime/runtime';
import 'jquery/dist/jquery.slim';
import 'bootstrap/dist/js/bootstrap.bundle';

import '../scss/app.scss';

// import initMyComponent from "./components/my-component";

if ('serviceWorker' in navigator) {
  window.addEventListener('load', function () {
    navigator.serviceWorker
      .register('/js/service-worker.js')
      .then((registration) => {
        console.log('SW registered: ', registration);
      })
      .catch((registrationError) => {
        console.log('SW registration failed: ', registrationError);
      });
  });
}

document.addEventListener('DOMContentLoaded', () => {
  // initMyComponent();
});
