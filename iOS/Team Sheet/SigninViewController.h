//
//  SigninViewController.h
//  Team Sheet
//
//  Created by James Guthrie on 15/02/2013.
//  Copyright (c) 2013 Hey Jimmy. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "AppDelegate.h"
#import "SBJson.h"

@interface SigninViewController : UIViewController {
    NSString *staffID;
    NSString *staffPIN;
    NSMutableData *staffResponseData;
    NSMutableData *accountResponseData;
    SBJsonParser *jsonParser;
    NSURLConnection *checkStaffConnection;
    NSURLConnection *accountDetailsConnection;
}

@property (weak, nonatomic) IBOutlet UITextField *inputTextField;
@property (retain, nonatomic) IBOutlet UILabel *headerLabel;
@property (retain, nonatomic) IBOutlet UILabel *timeLabel;

@property (nonatomic, retain) NSString *accountUUID;

@property (nonatomic, retain) NSMutableArray *staffIDArray;

@property (nonatomic, retain) NSMutableArray *staffPINArray;

@end
