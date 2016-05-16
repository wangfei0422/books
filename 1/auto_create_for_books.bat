rem create module and controller
call vendor\zendframework\zftool\zf2.bat create module Books

rem IndexController
call vendor\zendframework\zftool\zf2.bat create controller Index Books
call vendor\zendframework\zftool\zf2.bat create action index Index Books
call vendor\zendframework\zftool\zf2.bat create action sign_in Index Books

rem UserController
call vendor\zendframework\zftool\zf2.bat create controller User Books
call vendor\zendframework\zftool\zf2.bat create action add User Books
call vendor\zendframework\zftool\zf2.bat create action delete User Books
call vendor\zendframework\zftool\zf2.bat create action edit User Books
call vendor\zendframework\zftool\zf2.bat create action list User Books
call vendor\zendframework\zftool\zf2.bat create action page User Books
call vendor\zendframework\zftool\zf2.bat create action user_manage User Books
call vendor\zendframework\zftool\zf2.bat create action book_manage User Books
call vendor\zendframework\zftool\zf2.bat create action book_borrowed_manage User Books
call vendor\zendframework\zftool\zf2.bat create action book_feedback_manage User Books
call vendor\zendframework\zftool\zf2.bat create action article_manage User Books
call vendor\zendframework\zftool\zf2.bat create action article_feedback_manage User Books
call vendor\zendframework\zftool\zf2.bat create action log_manage User Books
call vendor\zendframework\zftool\zf2.bat create action config_manage User Books
call vendor\zendframework\zftool\zf2.bat create action book_type_manage User Books
call vendor\zendframework\zftool\zf2.bat create action not_manager User Books

rem BookController
call vendor\zendframework\zftool\zf2.bat create controller Book Books
call vendor\zendframework\zftool\zf2.bat create action verify Book Books
call vendor\zendframework\zftool\zf2.bat create action add Book Books
call vendor\zendframework\zftool\zf2.bat create action delete Book Books
call vendor\zendframework\zftool\zf2.bat create action edit Book Books
call vendor\zendframework\zftool\zf2.bat create action list Book Books
call vendor\zendframework\zftool\zf2.bat create action page Book Books
call vendor\zendframework\zftool\zf2.bat create action borrow Book Books
call vendor\zendframework\zftool\zf2.bat create action cancel Book Books
call vendor\zendframework\zftool\zf2.bat create action return Book Books
call vendor\zendframework\zftool\zf2.bat create action pay_pledge Book Books

rem BookFeedbackController
call vendor\zendframework\zftool\zf2.bat create controller BookFeedback Books
call vendor\zendframework\zftool\zf2.bat create action verify BookFeedback Books
call vendor\zendframework\zftool\zf2.bat create action add BookFeedback Books
call vendor\zendframework\zftool\zf2.bat create action delete BookFeedback Books
call vendor\zendframework\zftool\zf2.bat create action edit BookFeedback Books

rem ArticleController
call vendor\zendframework\zftool\zf2.bat create controller Article Books
call vendor\zendframework\zftool\zf2.bat create action verify Article Books
call vendor\zendframework\zftool\zf2.bat create action add Article Books
call vendor\zendframework\zftool\zf2.bat create action delete Article Books
call vendor\zendframework\zftool\zf2.bat create action edit Article Books
call vendor\zendframework\zftool\zf2.bat create action list Article Books
call vendor\zendframework\zftool\zf2.bat create action page Article Books

rem ArticleFeedbackController
call vendor\zendframework\zftool\zf2.bat create controller ArticleFeedback Books
call vendor\zendframework\zftool\zf2.bat create action verify ArticleFeedback Books
call vendor\zendframework\zftool\zf2.bat create action add ArticleFeedback Books
call vendor\zendframework\zftool\zf2.bat create action delete ArticleFeedback Books
call vendor\zendframework\zftool\zf2.bat create action edit ArticleFeedback Books