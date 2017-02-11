export class GiftModel
{
  giftName: string;
  giftLabel: string;
  giftId: string;
  giftImage: string;
  articleId: string;

  constructor (giftName: string, giftLabel: string, giftId: string, giftImage: string, articleId: string) {
    this.giftName = giftName;
    this.giftLabel = giftLabel;
    this.giftId = giftId;
    this.giftImage = giftImage;
    this.articleId = articleId;
  }
}
