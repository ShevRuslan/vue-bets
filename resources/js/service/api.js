import axios from 'axios';

class Api {
  //Запрос на апи
  getResource = async (url, data, method, headers = {}) => {
    let response = null;
    try {
      response = await axios({
        url:`api/${url}`,
        method: method,
        body: data,
        headers: {
          'Content-Type': 'application/json',
          ...headers
        }
      });
    }
    catch  {
      return response.error = "Возникла ошибка, попробуйте позже";
    }

    return response.data;
  };
  //Функция для создание get-параметром
  createGetParams = (data) => {
    let params = '';
    for (const param in data) {
      let stringParam =`${param}=${data[param]}`;
      stringParam += '&';
      params += stringParam;
    }
    return params;
  }
  //Поиск матчей для игроков (личных и с другими соперниками)
  searchBySportsmen = async (data) => {
    let url = 'commonMatch?' + this.createGetParams(data);
    const response = await this.getResource(url, null, 'GET');
    return response;
  }
  //Поиск спортсменов
  searchSportsmen = async (data) => {
    let url = 'sportsmen?' + this.createGetParams(data)
    const response = await this.getResource(url, null, 'GET');
    return response;
  }
  //Получение всех чемпионатов
  getAllChamps = async () => {
    let url = 'getAllChamps';
    const response = await this.getResource(url, null, 'GET');
    return response;
  }
  //Получение даты последнего обновления
  getLastUpdateDate = async () => {
    let url = 'getLastUpdateDate';
    const response = await this.getResource(url, null, 'GET');
    return response;
  }
  //Получение матчей из линии
  getLineMatches = async () => {
    let url = 'line'
    const response = await this.getResource(url, null, 'GET');
    return response;
  }
  //Получение чемпионатов из линии
  getLineChamps = async () => {
    let url = 'getLineChamps'
    const response = await this.getResource(url, null, 'GET');
    return response;
  }
  //Получение данных для таблицы ставок
  getBetsMatch = async (data) => {
    let url = 'getBetsMatch?' + this.createGetParams(data);
    const response = await this.getResource(url, null, 'GET');
    return response;
  }
}
export default new Api();