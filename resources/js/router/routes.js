import Home from '../pages/Home';
import Line from '../pages/Line';
import Search from '../pages/Search'
const routes = [
  {
    path: '/',
    name: 'home',
    component: Search,
  },
  {
    path: '/line-match',
    name: 'LineMatch',
    component: Line,
  },
];

export default routes;