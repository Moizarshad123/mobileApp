importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js');
   
// firebase.initializeApp({
//     apiKey: "AIzaSyCHBOmN-DUkrXstnZG1WNXp6EGuzMuAbMg",
//     authDomain: "side-hustle-763af.firebaseapp.com",
//     projectId: "side-hustle-763af",
//     storageBucket: "side-hustle-763af.appspot.com",
//     messagingSenderId: "35016346526",
//     appId: "1:35016346526:web:4a1a6090809a4e5cb1a48f"
// });

firebase.initializeApp({
    apiKey: "AIzaSyBpf6y0tF-8AI-EA33lKyfbgzISTwBA90g",
    authDomain: "side-hustle-app-f1cb7.firebaseapp.com",
    projectId: "side-hustle-app-f1cb7",
    storageBucket: "side-hustle-app-f1cb7.appspot.com",
    messagingSenderId: "158889797902",
    appId: "1:158889797902:web:ca7c30393cd7cb70970f5f",
    measurementId: "G-08PV8SJDM5"
});
  
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function({data:{title,body,icon}}) {
    return self.registration.showNotification(title,{body,icon});
});
