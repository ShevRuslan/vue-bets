
import Line from '../pages/Line';
import Search from '../pages/Search'
const routes = [
  {
    path: '/',
    name: 'home',
    component: Search,
  },
  {
    path: '/line',
    name: 'LineMatch',
    component: Line,
  },
];

export default routes;