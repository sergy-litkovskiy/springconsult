import {Component, OnInit} from '@angular/core';
import { GiftService } from '../services/gift-service';
import { GiftModel } from '../models/gift-model';
import { GiftSubscribeModel } from '../models/gift-subscribe-model';

@Component({
  selector: 'gift-container',
  templateUrl: '/app-angular/app/components/app.gift-component-view.html',
  providers: [GiftService]
})

export class GiftContainerComponent implements OnInit
{
  giftModelList: GiftModel[];

  constructor (private giftService: GiftService) {}

  ngOnInit () {
    this.getModelList();
  }

  getModelList () {
    this.giftService
        .getGiftModelList()
        .subscribe((giftList: GiftModel[]) => this.giftModelList = giftList);
  }

  sendGift(userName: HTMLInputElement, email: HTMLInputElement, giftId: HTMLInputElement, giftName: HTMLInputElement): void {
    console.log(`
      Adding giftId: ${giftId.value} | giftName: ${giftName.value} | email: ${email.value} | user: ${userName.value}
    `);

    let giftSubscribeModel = new GiftSubscribeModel(userName.value, email.value, giftId.value, giftName.value);

    this.giftService
        .sendGiftRequest(giftSubscribeModel)
        .subscribe(data => console.log(data));
  }
}

