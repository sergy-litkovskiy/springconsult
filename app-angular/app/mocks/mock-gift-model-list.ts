import { GiftModel } from '../models/gift-model';

export class GiftMock
{
    giftMock:[GiftModel] = [
        { giftId: '1', giftName: 'gift1', giftDescription: 'Description for gift1' },
        { giftId: '2', giftName: 'gift2', giftDescription: 'Description for gift2' },
    ];

    getGiftList () {
        return this.giftMock;
    }
}
