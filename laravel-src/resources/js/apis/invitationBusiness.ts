/* 招待されている 事業所 一覧 API */
/* import client */
import axios from '@/apis/MyAxios';
/* for type */
import { AxiosResponse } from 'axios';
import { InvitationBusiness } from '@/types';

/***********************************
 * export REST API 定義
 ***********************************/
// ベースURL
const BASE_URL = '/invitationBusiness'

/**
 * @return {Response} 招待されている 事業所一覧 一覧取得
 */
type Response = Promise<AxiosResponse<{ data:  InvitationBusiness[] }>>;
export const fetchAll = (): Response => axios.get(BASE_URL);
