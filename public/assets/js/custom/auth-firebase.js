// Firebase
var config = {
    apiKey: "AIzaSyAqV1IWPx4Vg8kZcL4VPS79qA-fCiiixn0",
    authDomain: "aidby-d4cb5.firebaseapp.com",
    projectId: "aidby-d4cb5",
    storageBucket: "aidby-d4cb5.appspot.com",
    messagingSenderId: "541574790641",
    appId: "1:541574790641:web:d7c7a7c6c71f5faf79d850",
    measurementId: "G-X80MPPJY8D"
};
firebase.initializeApp(config);

var base_Url = $('#baseUrl').val();

var googleProvider = new firebase.auth.GoogleAuthProvider();
var googleCallbackLink = base_Url + '/auth/login/google/callback';

async function socialSignin(provider, userType) {
    var socialProvider = null;
     if (provider == "google") {
        socialProvider = googleProvider;
        document.getElementById('social-login-form').action = googleCallbackLink;
        document.getElementById('social-login-type').value = provider;
        document.getElementById('social-login-user-type').value = userType;
    } else {
        return;
    }

    firebase.auth()
        .signInWithPopup(socialProvider)
        .then((result) => {
            /** @type {firebase.auth.OAuthCredential} */
            var credential = result.credential;
            var token = credential.accessToken;
            var user = result.user;

            console.log(user.providerData[0]);
            // return;

            document.getElementById('social-login-token').value = user.providerData[0].uid;
            document.getElementById('social-login-email').value = user.providerData[0].email;
            document.getElementById('social-login-fullname').value = user.providerData[0].displayName;
            document.getElementById('social-login-form').submit();
        }).catch((error) => {
            console.log(error);
        });
}
// End Firebase


$(".social-login").click(function (event) {
    event.preventDefault();
    var socialTitle = $(this).attr('socialTitle');
    var userType = $(this).attr('userType');
    socialSignin(socialTitle, userType);
});

/** Get token */
// firebase.initializeApp(config);
const messaging = firebase.messaging();
function initFirebaseMessagingRegistration() {
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function (token) {
            $('.device_token').val(token);
        }).catch(function (err) {
            console.log('User Chat Token Error *** ' + err);
        });
}
messaging.onMessage(function (payload) {
    const noteTitle = payload.notification.title;
    const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
});
initFirebaseMessagingRegistration();