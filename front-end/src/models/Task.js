import Api from "../services/Api";
import moment from "moment";

const resource = 'tasks'
const api = new Api()

export default class Task {

    static async listPaginated(page) {
        if (!page) page = 1

        return await api.request({
            url: `tasks?page=${page}`,
            method: 'get'
        })
    }

    static async filter(filter, page) {
        let start = moment(filter.startAt).format('yyyy-MM-DD')
        let end = moment(filter.endAt).format('yyyy-MM-DD')
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
            startAt: moment(data.start_at).format('yyyy-MM-DD'),
            endAt: moment(data.end_at).format('yyyy-MM-DD'),
            finishAt: moment().format('yyyy-MM-DD'),
            type: data.type_id,
        })
    }

    static async create(data) {
        return await api.request({
            url: `${resource}`,
            method: 'post',
            data: {
                ...data,
                startAt: moment(data.startAt).format('yyyy-MM-DD'),
                endAt: moment(data.endAt).format('yyyy-MM-DD')
            }
        })
    }

    static async update(data) {
        return await api.request({
            url: `${resource}/${data.id}`,
            method: 'put',
            data: {
                ...data,
                startAt: moment(data.startAt).format('yyyy-MM-DD'),
                endAt: moment(data.endAt).format('yyyy-MM-DD'),
            }
        })
    }

    static async delete(id) {
        return await api.request({
            url: `${resource}/${id}`,
            method: 'delete'
        })
    }

    static async details(id) {

    }

}