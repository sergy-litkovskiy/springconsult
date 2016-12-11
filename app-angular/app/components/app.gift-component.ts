import { Component } from '@angular/core';

class GiftModel
{
  userName: string;
  email: string;

  constructor (userName: string, email: string) {
    this.userName = userName;
    this.email = email;
  }
}

@Component({
  selector: 'gift-form-list',
  inputs: ['giftModel'],
  host: {
    class: 'row'
  },
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
  giftModels: GiftModel[];

  constructor() {
    this.giftModels = [
      new GiftModel('Angular 2', 'email1@gmail.com'),
      new GiftModel('Fullstack', 'email2@gmail.com'),
    ];
  }

  sendGift(userName: HTMLInputElement, email: HTMLInputElement): boolean {
    console.log(`Adding article user name: ${userName.value} and email: ${email.value}`);
    return false;
  }
}

