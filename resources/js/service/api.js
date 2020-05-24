import axios from 'axios';

class Api {
  getResource = async (url, data, method, headers = {}) => {
    const response = await axios({
      url:`api/${url}`,
      method: method,
      body: data,
      headers: {
        'Content-Type': 'application/json',
        ...headers
      }
    });

    return response.data;
  };
  createGetParams = (data) => {
    let params = '';
    for (const param in data) {
      let stringParam =`${param}=${data[param]}`;
      stringParam += '&';
      params += stringParam;
    }
    return params;
  }
  searchBySportsmen = async (data) => {
    let url = 'search?' + this.createGetParams(data);
    const response = await this.getResource(url, null, 'GET');
    return response;
  }
  searchSportsmen = async (data) => {
    let url = 'sportsmen?' + this.createGetParams(data)
    const response = await this.getResource(url, null, 'GET');
    return response;
  }
}
export default new Api();