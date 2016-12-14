import { Component } from '@angular/core';
import { GiftModel } from '../models/app.gift-model';

@Component({
  selector: 'gift-container',
  template: `
    <!--<gift-from *ngFor="let giftForm of giftFormList" [giftForm]="giftForm"></gift-from>-->
    HERE!!!
  `,
})

export class GiftContainerComponent
{
  giftFormList: GiftModel[] = [];

  constructor() {
    this.giftFormList = [
      new GiftModel('Gift1', 'gift1 description'),
      new GiftModel('Gift2', 'gift2 description'),
    ];
  }

  sendGift(userName: HTMLInputElement, email: HTMLInputElement): boolean {
    console.log(`Adding article user name: ${userName.value} and email: ${email.value}`);
    return false;
  }
}

