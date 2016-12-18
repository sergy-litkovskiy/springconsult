import { Injectable } from "@angular/core";
import { GiftMock } from '../mocks/mock-gift-model-list';
import { GiftModel } from '../models/gift-model';

@Injectable()
export class GiftService
{
    giftModelList: GiftModel[] = [];

    constructor () {
        var giftMock: GiftMock = new GiftMock();

        this.giftModelList = giftMock.getGiftMockModelList();
    }

    getGiftModelList() {
        return Promise.resolve(this.giftModelList);
    }
}