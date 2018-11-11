import { BrowserModule } from '@angular/platform-browser';
import { ErrorHandler, NgModule } from '@angular/core';
import { IonicApp, IonicErrorHandler, IonicModule } from 'ionic-angular';
import { SplashScreen } from '@ionic-native/splash-screen';
import { StatusBar } from '@ionic-native/status-bar';
import { IonicStorageModule } from '@ionic/storage';
import { MyApp } from './app.component';
import { HomePage } from '../pages/home/home';
import { PlacesService } from '../services/places.services';
import { Geolocation } from '@ionic-native/geolocation';
import { MapPage } from '../pages/map/map';
import { LocationTrackerProvider } from '../providers/location-tracker/location-tracker';

import { BackgroundGeolocation } from '@ionic-native/background-geolocation';
import { NewPlacePage } from '../pages/new-place/new-place';

import { TooltipsModule } from 'ionic-tooltips';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { LoginPage } from '../pages/login/login';
import { AngularFireModule } from '@angular/fire';
import { AngularFireAuthModule } from '@angular/fire/auth';
import { RegisterPage } from '../pages/register/register';
import { AngularFirestoreModule } from 'angularfire2/firestore';
import { firebaseConfig } from './credentials';

 
const firebaseAuth = {apiKey: "AIzaSyBfbbmqEjLKEpTdh_gI8h4PHobyUVHcNhk",
    authDomain: "traintracking-93a52.firebaseapp.com",
    databaseURL: "https://traintracking-93a52.firebaseio.com",
    projectId: "traintracking-93a52",
    storageBucket: "traintracking-93a52.appspot.com",
    messagingSenderId: "875280111233"
}

@NgModule({
  declarations: [
    MyApp,
    HomePage,
    MapPage,
    NewPlacePage,
    LoginPage,
    RegisterPage
  ],
  imports: [
    BrowserModule,
    IonicModule.forRoot(MyApp),
    IonicStorageModule.forRoot(),
    TooltipsModule,
    BrowserAnimationsModule,
    AngularFireModule.initializeApp(firebaseAuth),
    AngularFireModule.initializeApp(firebaseConfig),
    AngularFireAuthModule,
    AngularFirestoreModule
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    HomePage,
    MapPage,
    NewPlacePage,
    LoginPage,
    RegisterPage
  ],
  providers: [
    StatusBar,
    SplashScreen,
    {provide: ErrorHandler, useClass: IonicErrorHandler},
    BackgroundGeolocation,
    PlacesService,
    Geolocation,
    Storage,
    LocationTrackerProvider
  ]
})
export class AppModule {}
