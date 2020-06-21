import Home from '../pages/Home';
import Line from '../pages/Line';
import Search from '../pages/Search'
const routes = [
  {
    path: '/',
    name: 'home',
    component: Line,
  },
  {
    path: '/line-match',
    name: 'LineMatch',
    component: Search,
  },
];

export default routes;