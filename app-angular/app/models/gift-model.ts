export class GiftModel
{
  giftName: string;
  giftDescription: string;
  giftId: string;

  constructor (giftName: string, giftDescription: string, giftId: string) {
    this.giftName = giftName;
    this.giftDescription = giftDescription;
    this.giftId = giftId;
  }
}
