//
//  PhotoViewController.h
//  Team Sheet
//
//  Created by James Guthrie on 16/02/2013.
//  Copyright (c) 2013 Hey Jimmy. All rights reserved.
//

#import <UIKit/UIKit.h>
#import "StaffMember.h"
#import <AVFoundation/AVFoundation.h>
#import <ImageIO/ImageIO.h>
#import "SBJson.h"
#import "ASIFormDataRequest.h"
#import "SigninViewController.h"

@interface PhotoViewController : UIViewController <UITableViewDelegate, UITableViewDataSource> {
    NSString *dateStringForFilename;
    NSString *timeStringForFilename;
    NSMutableData *responseData;
    UIImage *rotatedImage;
    NSURLConnection *noticesConnection;
    NSURLConnection *photoConnection;
    SBJsonParser *jsonParser;
}

@property (nonatomic, retain) IBOutlet UIView *vImagePreview;

@property (retain, nonatomic) IBOutlet UILabel *staffNameLabel;

@property (nonatomic, retain) IBOutlet UIButton *finishButton;

@property (nonatomic, retain) IBOutlet UIImageView *buttonImage;

@property (retain, nonatomic) IBOutlet UITableView *noticesTableView;

@property (nonatomic, retain) NSString *accountUUID;

@property (nonatomic, retain) StaffMember *staffMember;

@property (nonatomic, retain) AVCaptureStillImageOutput *stillImageOutput;

@property (nonatomic, retain) NSMutableArray *noticesArray;

@end
