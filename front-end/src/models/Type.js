import Api from "../services/Api";

const resource = 'types'
const api = new Api()

export default class Type {

    static async list() {
        return await api.request({
            url: `${resource}`,
            method: 'get'
        })
    }

    static async create(data) {
        return await api.request({
            url: `${resource}`,
            method: 'post',
            data: {...data }
        })
    }

    static async update(data) {
        return await api.request({
            url: `${resource}/${data.id}`,
            method: 'put',
            data: {...data }
        })
    }

    static async delete(data) {
        return await api.request({
            url: `${resource}/${data.id}`,
            method: 'delete'
        })
    }
}