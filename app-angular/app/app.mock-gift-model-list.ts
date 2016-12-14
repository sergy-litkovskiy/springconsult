import { GiftModel } from './models/app.gift-model';

export class GiftMock
{
    giftMock:[GiftModel] = [
        {giftName: 'gift1', giftDescription: 'Description for gift1'},
        {giftName: 'gift2', giftDescription: 'Description for gift2'},
    ];

    getGiftList () {
        return this.giftMock;
    }
}
