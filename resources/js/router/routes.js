import Home from '../pages/Home';
import Line from '../pages/Line';
const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/line-match',
    name: 'LineMatch',
    component: Line,
  },
];

export default routes;