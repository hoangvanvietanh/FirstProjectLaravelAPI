<?php

namespace App\Http\Controllers\API;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ImageCreateRequest;
use App\Http\Requests\ImageUpdateRequest;
use App\Repositories\ImageRepository;
use App\Validators\ImageValidator;

/**
 * Class ImagesController.
 *
 * @package namespace App\Http\Controllers;
 */
class ImagesController extends BaseController
{
    /**
     * @var ImageRepository
     */
    protected $repository;

    /**
     * @var ImageValidator
     */
    protected $validator;

    /**
     * ImagesController constructor.
     *
     * @param ImageRepository $repository
     * @param ImageValidator $validator
     */
    public function __construct(ImageRepository $repository, ImageValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $images = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $images,
            ]);
        }

        return view('images.index', compact('images'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ImageCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $image = $this->repository->create($request->all());

            $response = [
                'message' => 'Image created.',
                'data'    => $image->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $image = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $image,
            ]);
        }

        return view('images.show', compact('image'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $image = $this->repository->find($id);

        return view('images.edit', compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ImageUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ImageUpdateRequest $request, $id)
    {

        $image = Input::file('file'); //i think you call your input on the html form as 'file'
        $img = Image::make($image)->resize(320, 240, function ($constraint) {
            $constraint->aspectRatio();
        });
        $imgName = rand(11111, 99999).'.'.$image->getClientOriginalExtension();
        $this->repository->uploadImage($img, $imgName);

        //Continue your logic here
//        try {
//
//            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
//
//            $image = $this->repository->update($request->all(), $id);
//
//            $response = [
//                'message' => 'Image updated.',
//                'data'    => $image->toArray(),
//            ];
//
//            if ($request->wantsJson()) {
//
//                return response()->json($response);
//            }
//
//            return redirect()->back()->with('message', $response['message']);
//        } catch (ValidatorException $e) {
//
//            if ($request->wantsJson()) {
//
//                return response()->json([
//                    'error'   => true,
//                    'message' => $e->getMessageBag()
//                ]);
//            }
//
//            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
//        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Image deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Image deleted.');
    }

}
