/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

let profilPictureInput = document.getElementById('character_profilPicture');
let prifilePicture = document.getElementById('ProfilePicture');

profilPictureInput.onchange = evt => {
    console.log('input changed');
    const [file] = profilPictureInput.files
    if (file) {
        prifilePicture.src = URL.createObjectURL(file)
    }
  }