export class GiftModel
{
  giftName: string;
  giftDescription: string;
  giftId: string;
  giftImage: string;

  constructor (giftName: string, giftDescription: string, giftId: string, giftImage: string) {
    this.giftName = giftName;
    this.giftDescription = giftDescription;
    this.giftId = giftId;
    this.giftImage = giftImage;
  }
}
