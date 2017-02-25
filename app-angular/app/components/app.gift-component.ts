import {Component, OnInit} from '@angular/core';
import {GiftService} from '../services/gift-service';
import {GiftModel} from '../models/gift-model';

@Component({
    selector: 'gift-container',
    templateUrl: '/app-angular/app/components/app.gift-component-view.html',
    providers: [GiftService]
})

export class GiftContainerComponent implements OnInit {
    giftModelList: GiftModel[];

    constructor(private giftService: GiftService) {}

    ngOnInit() {
        this.getModelList();
    }

    getModelList() {
        this.giftService
            .getGiftModelList()
            .subscribe((giftList: GiftModel[]) => this.giftModelList = giftList);
    }
}

