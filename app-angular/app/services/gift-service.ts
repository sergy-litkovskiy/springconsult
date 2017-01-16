import { Injectable } from "@angular/core";
import { GiftMock } from '../mocks/mock-gift-model-list';
import { GiftModel } from '../models/gift-model';
import { Http, Response } from '@angular/http';
import { Observable }     from 'rxjs/Observable';

@Injectable()
export class GiftService
{
    giftModelList: GiftModel[] = [];

    // private giftListUrl = '/gift/list';  // URL to web API

    // constructor (private http: Http) {
    constructor () {
        var giftMock: GiftMock = new GiftMock();

        this.giftModelList = giftMock.getGiftMockModelList();
    }

    getGiftModelList() {
        return Promise.resolve(this.giftModelList);
    }

//     getGiftModelList (): Observable<GiftModel[]> {
//         return this.http.get(this.giftListUrl)
//             .map(this.extractData)
//             .catch(this.handleError);
//     }
//
//     private extractData(res: Response) {
//         let body = res.json();
//         return body.data || { };
//     }
//
//     private handleError (error: Response | any) {
//         // In a real world app, we might use a remote logging infrastructure
//         let errMsg: string;
//         if (error instanceof Response) {
//             const body = error.json() || '';
//             const err = body.error || JSON.stringify(body);
//             errMsg = `${error.status} - ${error.statusText || ''} ${err}`;
//         } else {
//             errMsg = error.message ? error.message : error.toString();
//         }
// console.error(errMsg);
//
//         return Observable.throw(errMsg);
//     }
}