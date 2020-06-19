import Vue from 'vue'
import Router from 'vue-router'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css' // progress bar style
import {getToken} from "@/utils/sessionUtil";
Vue.use(Router);

export const constantRoutes = [
    {
        path: '/',
        name: 'home',
        component: () => import('@/views/home/index'),
        meta: {
            title: 'Home',
        }
    },
    {
        path: '/browse',
        name: 'browse',
        component: () => import('@/views/browse/index'),
        meta: {
            title: 'Browse',
        }
    },
    {
        path: '/search',
        name: 'search',
        component: () => import('@/views/search/index'),
        meta: {
            title: 'Search',
        }
    },
    {
        name: 'login',
        path: '/login',
        component: () => import('@/views/login/index'),
        meta: {
            title: 'Login',
        }
    },
    {
        name: 'register',
        path: '/register',
        component: () => import('@/views/register/index'),
        meta: {
            title: 'Register',
        }
    },
    {
        name: 'upload',
        path: '/upload',
        component: () => import('@/views/upload/index2'),
        meta: {
            title: 'Upload',
        }
    },
    {
        name: 'photos',
        path: '/photos',
        component: () => import('@/views/photos/index'),
        meta: {
            title: 'Photos',
        }
    },
    {
        name: 'photo_detail',
        path: '/photos/:id',
        component: () => import('@/views/photos/detail'),
        meta: {
            title: 'Photo Detail'
        }
    },
    {
        name: 'edit_photo',
        path: '/edit/:id',
        component: () => import('@/views/photos/edit'),
        meta: {
            title: 'Edit Photo'
        }
    },
    {
        name: 'favourites',
        path: '/favourites',
        component: () => import('@/views/favourites/index'),
        meta: {
            title: 'Favourites',
        }
    },
    {
        name: 'backend_console',
        path: '/console',
        component: () => import('@/views/console/index'),
        hidden: true,
        meta: {
            title: 'Console',
        }
    },

    {
        path: '/aboutMe',
        component: () => import('@/views/profile/developerInfo'),
        hidden: true,
        meta: {
            title: 'AboutMe',
        }
    },
    {
        path: '/contactMe',
        component: () => import('@/views/profile/ContactMe'),
        hidden: true,
        meta: {
            title: 'ContactMe',
        }
    },
];
const createRouter = () => new Router({
    // mode: 'history', // require service support
    scrollBehavior: () => ({ y: 0 }),
    routes: constantRoutes
});

const router = createRouter();
const whiteList = ['/login', '/', '/aboutMe', '/contactMe', '/browse', '/search', '/photos', '/favourites', '/upload','/register'];
router.beforeEach(async(to, from, next) => {
    NProgress.start();
    document.title = to.meta.title;

    const hasToken = getToken();

    if (hasToken) {
        if (to.path === '/login') {
            next({ path : '/'});
            NProgress.done();
        } else {
            next()
        }
    } else {
        if (whiteList.indexOf(to.path) !== -1 || to.path.startsWith('/photos')) {
            next();
        } else {
            next('/login');
            NProgress.done();
        }
    }

});
router.afterEach(() => {
    NProgress.done();
});
export default router