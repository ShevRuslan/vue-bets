import Home from '../pages/Home';
import Line from '../pages/Line';
const routes = [
  {
    path: '/',
    name: 'home',
    component: Line,
  },
  {
    path: '/line-match',
    name: 'LineMatch',
    component: Home,
  },
];

export default routes;