import { GiftModel } from '../models/gift-model';

export class GiftMock
{
    giftMockModelList:[GiftModel] = [
        { giftId: '1', giftName: 'gift1', giftDescription: 'Description for gift1' },
        { giftId: '2', giftName: 'gift2', giftDescription: 'Description for gift2' },
    ];

    getGiftMockModelList () {
        return this.giftMockModelList;
    }
}
