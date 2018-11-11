import { Component, ViewChild } from '@angular/core';
import { IonicPage, NavController, NavParams, AlertController} from 'ionic-angular';
import { AngularFireAuth } from '@angular/fire/auth';
import { HomePage } from '../home/home';

/**
 * Generated class for the LoginPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {

  @ViewChild('username') uname;
  @ViewChild('password') pwd;

  constructor(private alertCtrl: AlertController, private fire:AngularFireAuth,public navCtrl: NavController, public navParams: NavParams) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad LoginPage');
  }
  alert(message:string){
    this.alertCtrl.create({
      title: "Info!",
      subTitle: message,
      buttons: ['OK']
    }).present();
  }
  SigninUser(){
    console.log(this.uname.value,this.pwd.value);
    this.fire.auth.signInWithEmailAndPassword(this.uname.value,this.pwd.value)
    .then(data=>{
      console.log("got data",this.fire.auth.currentUser);
      this.alert("Success! You're logged in.");
      this.navCtrl.setRoot(HomePage);
    }).catch(error=>{
      console.log("got an error", error);
      this.alert(error.message);
    })
  }

}
