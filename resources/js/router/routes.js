import LinePage from '../pages/LinePage';
import SearchPage from '../pages/SearchPage'
const routes = [
  {
    path: '/',
    name: 'home',
    component: SearchPage,
  },
  {
    path: '/line',
    name: 'line',
    component: LinePage,
  },
];

export default routes;