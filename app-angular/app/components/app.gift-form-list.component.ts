import { Component } from '@angular/core';
import { GiftModel } from '../models/app.gift-model';

@Component({
    selector: 'gift-form',
    template: `
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
  `,
})

export class GiftFormListComponent
{
    giftModel: GiftModel;
}

