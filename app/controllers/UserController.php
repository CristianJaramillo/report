<?php 

use Report\Managers\RegisterManager;
use Report\Repositories\CategoryRepo;
use Report\Repositories\DepartamentRepo;
use Report\Repositories\UserRepo;

class UserController extends BaseController
{

	/**
	 * @var Report\Repositories\UserRepo 
	 */
	protected $userRepo;

	/**
	 * @param Report\Repositories\UserRepo $userRepo
	 * @return void 
	 */
	public function __construct(UserRepo $userRepo)
	{
		$this->userRepo = $userRepo;
	}

	/**
	 * POST /account
	 *
	 * @return \View
	 * @throws \Report\Managers\ValidationException
	 */
	public function account($user = null)
	{
        return $this->show();
	}

	/**
	 * @return \View
	 * @throws \Report\Managers\ValidationException
	 */
	public function dashboard(){

		$this->addParam(['users' => $this->userRepo->authorized(false)]);

		return $this->show();
	}

	/**
	 * POST /register
	 *
	 * @return \View
	 * @throws \Report\Managers\ValidationException
	 */
	public function register()
	{
        $manager = new RegisterManager($this->userRepo->newUser(), Input::all());
        
        $manager->save();

        Session::flash('message', 'register-sucess');

        return Redirect::route('sing-in');
	}

	/**
	 * GET /sing-in
	 *
	 * @return \View
	 */
	public function singUp()
	{
		// New Report\Managers\CategoryRepo
		$categories = new CategoryRepo();
		// New Report\Managers\DepartamentRepo
		$departamens = new DepartamentRepo();

		// add params 
		$this->addParam(array(
			'categories'  => $categories->getList(),
			'departaments' => $departamens->getList()
		));

		// return view
		return $this->show();

	}

}