import {Component, OnInit, Input} from '@angular/core';
import {GiftService} from '../services/gift-service';
import {GiftSubscribeModel} from '../models/gift-subscribe-model';
import {GiftModel} from "../models/gift-model";

@Component({
    selector: 'gift-form',
    templateUrl: '/app-angular/app/components/app.gift-form-view.html',
    providers: [GiftService]
})

export class GiftFormComponent implements OnInit {
    giftSubscribeModel: GiftSubscribeModel;
    @Input() giftModel: GiftModel;

    constructor(private giftService: GiftService) {}

    ngOnInit() {
        this.giftSubscribeModel = new GiftSubscribeModel(null, null, null, null);
    }

    sendGift(userName: HTMLInputElement, email: HTMLInputElement, giftId: HTMLInputElement, giftName: HTMLInputElement): void {
        let subscribeModel = new GiftSubscribeModel(userName.value, email.value, giftId.value, giftName.value);

        this.giftService
            .sendGiftRequest(subscribeModel)
            .subscribe(
                data => {
                    email.value = null;
                    userName.value = null;
                    window.location.href = data.data;
                },
                errorMessage => {
                    console.log('sendGift subscribe - errorMessage', errorMessage)
                }
            );
    }
}

