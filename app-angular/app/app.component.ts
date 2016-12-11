import { Component } from '@angular/core';

@Component({
  selector: 'gift-form',
  template: `
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

export class GiftFormComponent
{
  constructor () {}

  sendGift(userName: HTMLInputElement, email: HTMLInputElement): boolean {
    console.log(`Adding article user name: ${userName.value} and email: ${email.value}`);
    return false;
  }
}
