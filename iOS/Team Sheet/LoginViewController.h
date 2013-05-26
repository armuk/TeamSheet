//
//  LoginViewController.h
//  Team Sheet
//
//  Created by James Guthrie on 29/01/2013.
//  Copyright (c) 2013 Hey Jimmy. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "SBJson.h"
#import "AppDelegate.h"

@interface LoginViewController : UIViewController {
    SBJsonParser *jsonParser;
    NSMutableData *responseData;
}

@property (weak, nonatomic) IBOutlet UITextField *emailTextField;
@property (weak, nonatomic) IBOutlet UITextField *passwordTextField;
@property (weak, nonatomic) IBOutlet UIButton *loginButton;
@property (weak, nonatomic) IBOutlet UIImageView *loginButtonImage;
@property (nonatomic, retain) NSMutableArray *emails;
@property (nonatomic, retain) NSMutableArray *passwords;

+ (NSString *)createSHA512:(NSString *)source;

@end