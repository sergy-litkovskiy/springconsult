import {Component, OnInit} from '@angular/core';
import { GiftService } from '../services/gift-service';
import { GiftModel } from '../models/gift-model';
import { GiftSubscribeModel } from '../models/gift-subscribe-model';

@Component({
  selector: 'gift-container',
  template: `
      <section class="promo_box">
          <div class="container">
              <div class="row">
                  <div class="post-recent col-sm-6 col-md-6 col-lg-6" *ngFor="let giftModel of giftModelList">
                      <div class="post-images">
                          <a href="/articles/">
                              <img class="img-rounded img-responsive" src="/img/subscribe/{{ giftModel.giftImage }}" alt=""/>
                          </a>
                      </div>

                      <div class="post-detail">
                          <h5>
                              <a href="/articles/">
                                  {{ giftModel.giftName }}
                              </a>
                          </h5>
                          <form class="gift-form" action="" novalidate="novalidate">
                              <div class="row">
                                  <div class="form-group">
                                      <div class="col-md-6">
                                          <input 
                                            type="email" 
                                            id="email" 
                                            name="email" 
                                            class="form-control form-control-sm" 
                                            data-msg-email="Введите валидный email" 
                                            data-msg-required="Введите ваш email" 
                                            value="" 
                                            placeholder="Ваш E-mail"  
                                            #email
                                          />
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="form-group">
                                      <div class="col-md-6">
                                          <input 
                                              type="text" 
                                              id="username" 
                                              name="username" 
                                              class="form-control form-control-sm"
                                              data-msg-required="Введите ваше имя" 
                                              value="" 
                                              placeholder="Имя"
                                              #userName
                                          />
                                          <input name="gid" type="hidden" value="{{ giftModel.giftId }}" #giftId>
                                          <input name="gname" type="hidden" value="{{ giftModel.giftName }}" #giftName>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-3 text-right">
                                      <button data-loading-text="Loading..." class="btn btn-default btn-sm" (click)="sendGift(userName, email, giftId, giftName)">
                                          <i class="fa fa-envelope-o"></i>
                                          Получить
                                      </button>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </section>
  `,
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

