import Api from "../services/Api";

const resource = 'types'

export default class Type {

    static async list() {
        const api = new Api()

        return await api.request({
            url: `${resource}`,
            method: 'get'
        })
    }

    static async create(data) {
        const api = new Api()

        return await api.request({
            url: `${resource}`,
            method: 'post',
            data: {...data }
        })
    }

    static async update(data) {
        const api = new Api()

        return await api.request({
            url: `${resource}/${data.id}`,
            method: 'put',
            data: {...data }
        })
    }

    static async delete(data) {
        const api = new Api()

        return await api.request({
            url: `${resource}/${data.id}`,
            method: 'delete'
        })
    }
}