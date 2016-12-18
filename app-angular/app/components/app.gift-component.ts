import {Component, OnInit} from '@angular/core';
import { GiftService } from '../services/gift-service';
import { GiftModel } from '../models/gift-model';

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
              <input name="gid" type="hidden" value="{{ giftModel.giftId }}" #giftId>
              <input name="gname" type="hidden" value="{{ giftModel.giftName }}" #giftName>
            </div>
            <button (click)="sendGift(userName, email, giftId, giftName)" class="">
              Get the Gift
            </button>
        </form>
    </div>
  `,
  providers: [GiftService]
})

export class GiftContainerComponent implements OnInit
{
  giftModelList: GiftModel[];

  constructor (private _giftService: GiftService) {}

  ngOnInit () {
    this.getModelList();
  }

  getModelList () {
    this._giftService
        .getGiftModelList()
        .then(giftModelList => this.giftModelList = giftModelList);
  }

  sendGift(userName: HTMLInputElement, email: HTMLInputElement, giftId: HTMLInputElement, giftName: HTMLInputElement): boolean {
    console.log(`
      Adding giftId: ${giftId.value} | giftName: ${giftName.value} | email: ${email.value} | user: ${userName.value}
    `);
    return false;
  }
}

