export class GiftSubscribeModel
{
  userName: string;
  email: string;
  giftId: string;
  giftName: string;

  constructor (userName: string, email: string, giftId: string, giftName: string) {
    this.userName = userName;
    this.email = email;
    this.giftId = giftId;
    this.giftName = giftName;
  }
}
