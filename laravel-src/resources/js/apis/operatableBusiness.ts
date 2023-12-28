/* 操作可能 事業所 API */
/* import client */
import axios from '@/apis/MyAxios';
/* for type */
import {AxiosResponse} from 'axios';
import { OperatableBusiness } from '@/types';

/***********************************
 * export REST API 定義
 ***********************************/
// ベースURL
const BASE_URL = '/operatableBusiness'

/**
 * @return {Response} 操作可能 事業所一覧 一覧取得
 */
type Response = Promise<AxiosResponse<{ data:  OperatableBusiness[] }>>;
export const fetchAll = (): Response => axios.get(BASE_URL);
