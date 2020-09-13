import axios from 'axios'
import store from './../store'
import Storage from 'local-storage-firmino'

axios.defaults.withCredentials = false
axios.defaults.baseURL = 'http://127.0.0.1:8000/api'
// axios.defaults.baseURL = 'http://appmobiplus.mobimix.com.br/api/v3'

export default class Api {

  constructor() {
    // console.log(Storage.get('token-user'))
    this.config = {
      headers: { Authorization: 'Bearer ' + Storage.get('token-user') },
    }
  }

  async request({url, data, method}) {

    switch (method) {
      case 'get':
        // console.log(this.config)
        return axios.get(url, this.config).catch(this.errorNotAuthenticate)
      case 'post':
        return axios.post(url, data, this.config).catch(this.errorNotAuthenticate)
      case 'put':
        return axios.put(url, data, this.config).catch(this.errorNotAuthenticate)
      case 'delete':
        return axios.delete(url, this.config).catch(this.errorNotAuthenticate)
    }
  }

  errorNotAuthenticate (err) {
    console.log({err})
    if (err.response.status === 401)
      Storage.delete('token-user')
    // if (err.message())
    return err.response
  }
}
