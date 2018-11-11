import { Component,ViewChild } from '@angular/core';
import { IonicPage, NavController, NavParams, AlertController } from 'ionic-angular';
import { AngularFireAuth } from '@angular/fire/auth';

/**
 * Generated class for the RegisterPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@IonicPage()
@Component({
  selector: 'page-register',
  templateUrl: 'register.html',
})
export class RegisterPage {
  @ViewChild('username') uname;
  @ViewChild('password') pwd;

  constructor(private alertCtrl: AlertController,public navCtrl: NavController, public navParams: NavParams, private fire: AngularFireAuth) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad RegisterPage');
  }
  alert(message:string){
    this.alertCtrl.create({
      title: "Info!",
      subTitle: message,
      buttons: ['OK']
    }).present();
  }
  RegisterUser(){
    this.fire.auth.createUserWithEmailAndPassword(this.uname.value,this.pwd.value)
    .then(data=>{
      console.log("got data",data);
      this.alert("Registered! You may now log in.");
    }).catch(error=>{
      console.log("got an error", error);
      this.alert(error.message);
    })
    console.log(this.uname.value,this.pwd.value);
  }

}
