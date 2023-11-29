import { createRouter, createWebHistory } from 'vue-router';
import routes from './routes';
import useAuth from '../composables/useAuth';

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(async (to, from, next) => {
    const { isUserAuthenticated } = useAuth();

    if (from.name === to.name) {
        return next();
    }

    const isUserLoggedIn = await isUserAuthenticated();

    if (isUserLoggedIn) {
        if (to.name === 'login') {
            return next({ name: 'users' });
        }
    } else {
        if (to.name !== 'login') {
            return next({ name: 'login' });
        }
    }
    return next();
});

export default router;
