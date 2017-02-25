import { Injectable } from "@angular/core";
import {Http, Response, Headers, RequestOptions} from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/Rx';

import { GiftModel } from '../models/gift-model';
import { GiftSubscribeModel } from "../models/gift-subscribe-model";

@Injectable()
export class GiftService
{
    giftModelList: GiftModel[] = [];

    private giftListUrl = '/gift/list';  // URL to web API
    private sendGiftSubscribeUrl = '/gift/subscribe';  // URL to web API

    constructor (private http: Http) {

    }

    getGiftModelList (): Observable<GiftModel[]> {
        return this.http.get(this.giftListUrl)
            .map(this.extractData)
            .catch(this.handleError);
    }

    private extractData(res: Response) {
        let giftList = [];
        let body = res.json();
        let dataList = body.data || [];

        if (dataList) {
            for (let data of dataList) {
                giftList.push(new GiftModel(data.name, data.label, data.id, data.image, data.article_id));
            }
        }

        return giftList;
    }

    private handleError (error: Response | any) {
        // In a real world app, we might use a remote logging infrastructure
        let errMsg: string;

        if (error instanceof Response) {
            errMsg = JSON.stringify(error.statusText);
        } else {
            errMsg = error.message ? error.message : error.toString();
        }

        return Observable.throw(errMsg);
    }

    sendGiftRequest(giftSubscribeModel: GiftSubscribeModel) {
        let data = giftSubscribeModel;
        let headers = new Headers();
        headers.append('Content-Type', 'application/json;charset=utf-8');

        let options = new RequestOptions({ headers: headers });

        return this.http.post(this.sendGiftSubscribeUrl, data, options)
            .map((data: Response) => data.json())
            .catch(this.handleError);
    }
}