import { GiftModel } from '../models/gift-model';

export class GiftMock
{
    giftMockModelList:[GiftModel] = [
        { giftId: '1', giftName: 'gift1', giftDescription: 'Description for gift1', giftImage: 'book_print_gold_fish.png' },
        { giftId: '2', giftName: 'gift2', giftDescription: 'Description for gift2', giftImage: 'my_book_print.jpg' },
    ];

    getGiftMockModelList () {
        return this.giftMockModelList;
    }
}
