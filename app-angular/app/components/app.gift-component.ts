import { Component } from '@angular/core';
// import {GiftModel} from '../models/app.gift-model';

@Component({
  selector: 'gift-container',
  template: `
    <div *ngFor="let giftModel of giftModelList">
        <p>{{ giftModel.giftName }}</p>  
        <p>{{ giftModel.giftDescription }}</p>  
        <form class="">
            <h3 class="">Get The Gift now</h3>
            <div class="field">
              <label for="user-name">Name:</label> 
              <input name="user-name" #userName>
            </div>
            <div class="field">
              <label for="email">Email:</label>
              <input name="email" #email>
            </div>
            <button (click)="sendGift(userName, email)" class="">
              Get the Gift
            </button>
        </form>
    </div>
  `
})

export class GiftContainerComponent
{
  giftModelList = [
    {giftName: 'gift1', giftDescriptiion: 'gift1 descr'},
    {giftName: 'gift2', giftDescriptiion: 'gift2 descr'},
  ];
  // constructor() {
  //   // this.giftModelList = [
  //   //     new GiftModel('gift1', 'gift1 descr'),
  //   //     new GiftModel('gift2', 'gift2 descr')
  //   // ];
  //   this.giftModelList = [
  //     {giftName: 'gift1', giftDescriptiion: 'gift1 descr'},
  //     {giftName: 'gift2', giftDescriptiion: 'gift2 descr'},
  //   ];
  // }

  sendGift(userName: HTMLInputElement, email: HTMLInputElement): boolean {
    console.log(`Adding article user name: ${userName.value} and email: ${email.value}`);
    return false;
  }
}

