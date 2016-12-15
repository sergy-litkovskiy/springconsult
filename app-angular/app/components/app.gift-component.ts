import { Component } from '@angular/core';
import { GiftMock } from '../mocks/mock-gift-model-list';

@Component({
  selector: 'gift-container',
  template: `
    <div *ngFor="let giftModel of giftModelMock.getGiftList()">
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
              <input name="gid" type="hidden" value="{{ giftModel.giftId }}" #giftId>
              <input name="gname" type="hidden" value="{{ giftModel.giftName }}" #giftName>
            </div>
            <button (click)="sendGift(userName, email, giftId, giftName)" class="">
              Get the Gift
            </button>
        </form>
    </div>
  `
})

export class GiftContainerComponent
{
  giftModelMock: GiftMock;

  constructor() {
    this.giftModelMock = new GiftMock();
  }

  sendGift(userName: HTMLInputElement, email: HTMLInputElement, giftId: HTMLInputElement, giftName: HTMLInputElement): boolean {
    console.log(`
      Adding giftId: ${giftId.value} | giftName: ${giftName.value} | email: ${email.value} | user: ${userName.value}
    `);
    return false;
  }
}

