import Api from './Api'

const resource = 'auth'

export default class Auth {

    static async authentication(user, callback) {
        let api = new Api()

        api.request({
            url: `${resource}/login`,
            method: 'post',
            data: user
        }).then(callback)
    }
}