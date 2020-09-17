import Api from "../services/Api";
import moment from "moment";

const resource = 'tasks'


export default class Task {

    static async listPaginated(page) {
        let api = new Api()
        if (!page) page = 1

        return await api.request({
            url: `tasks?page=${page}`,
            method: 'get'
        })
    }

    static async filter(filter, page) {
        let api = new Api()

        let start = moment(filter.start_at).format('yyyy-MM-DD')
        let end = moment(filter.end_at).format('yyyy-MM-DD')
        if (!page) page = 1

        return await api.request({
            url: `${resource}/filters/start/${start}/${end}?page=${page}`,
            method: 'get',
        })
    }

    static async check(data) {

        data.status = true
        return await Task.update({
            ...data,
            start_at: moment(data.start_at).format('yyyy-MM-DD'),
            end_at: moment(data.end_at).format('yyyy-MM-DD'),
            finish_at: moment().format('yyyy-MM-DD'),
            type: data.type_id,
        })
    }

    static async create(data) {
        let api = new Api()

        return await api.request({
            url: `${resource}`,
            method: 'post',
            data: {
                ...data,
                start_at: moment(data.start_at).format('yyyy-MM-DD'),
                end_at: moment(data.end_at).format('yyyy-MM-DD')
            }
        })
    }

    static async update(data) {
        let api = new Api()

        return await api.request({
            url: `${resource}/${data.id}`,
            method: 'put',
            data: {
                ...data,
                start_at: moment(data.start_at).format('yyyy-MM-DD'),
                end_at: moment(data.end_at).format('yyyy-MM-DD'),
            }
        })
    }

    static async delete(id) {
        let api = new Api()

        return await api.request({
            url: `${resource}/${id}`,
            method: 'delete'
        })
    }

    static async details(id) {

    }

}