//
//  PhotoViewController.m
//  Team Sheet
//
//  Created by James Guthrie on 16/02/2013.
//  Copyright (c) 2013 Hey Jimmy. All rights reserved.
//

#import "PhotoViewController.h"

@interface PhotoViewController ()

@end

@implementation PhotoViewController

@synthesize accountUUID, staffMember, stillImageOutput, buttonImage, finishButton, staffNameLabel, noticesTableView, noticesArray;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    noticesTableView.backgroundColor = [UIColor clearColor];
    NSLog(@"%@", staffMember.staffName);
    [finishButton setBackgroundImage:buttonImage.image forState:UIControlStateNormal];
    [staffNameLabel setText:staffMember.staffName];
    noticesArray = [[NSMutableArray alloc]init];
    NSString *parsedAccountURL = [NSString stringWithFormat:@"%@%@%@", @"https://clockinoutapp.appspot.com/_je/", accountUUID, @"-messages"];
    NSURL *accountURL = [NSURL URLWithString: parsedAccountURL];
    NSMutableURLRequest *accountRequest = [NSMutableURLRequest requestWithURL:accountURL
                                                                  cachePolicy:NSURLRequestReloadIgnoringLocalCacheData
                                                              timeoutInterval:60];
    noticesConnection = [[NSURLConnection alloc] initWithRequest:accountRequest delegate:self];
}

- (NSInteger)numberOfSectionsInTableView:noticesTableView {
    return noticesArray.count;
}


- (NSInteger)tableView:noticesTableView numberOfRowsInSection:(NSInteger)section
{
    return 1;
}

- (UITableViewCell *)tableView:noticesTableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *simpleTableIdentifier = @"SimpleTableItem";
    UITableViewCell *cell = [noticesTableView
                             dequeueReusableCellWithIdentifier:simpleTableIdentifier];
    if (cell == nil) {
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:simpleTableIdentifier];
    }
    cell.textLabel.text = [noticesArray objectAtIndex:indexPath.section];
    return cell;
}

//- (NSString *)tableView:noticesTableView titleForHeaderInSection:(NSInteger)section {
  //  if(section == 0)
    //    return @"Team Noticeboard";
//}


- (void) viewDidAppear:(BOOL)animated
{
    AVCaptureSession *session = [[AVCaptureSession alloc] init];
	session.sessionPreset = AVCaptureSessionPresetMedium;
    
	CALayer *viewLayer = self.vImagePreview.layer;
	NSLog(@"viewLayer = %@", viewLayer);
    
	AVCaptureVideoPreviewLayer *captureVideoPreviewLayer = [[AVCaptureVideoPreviewLayer alloc] initWithSession:session];
    captureVideoPreviewLayer.orientation = AVCaptureVideoOrientationLandscapeLeft;
    captureVideoPreviewLayer.frame = self.vImagePreview.bounds;
	[self.vImagePreview.layer addSublayer:captureVideoPreviewLayer];
    
	AVCaptureDevice *device = [self frontFacingCameraIfAvailable];
    
    NSError *error = nil;
	AVCaptureDeviceInput *input = [AVCaptureDeviceInput deviceInputWithDevice:device error:&error];
	if (!input) {
		// Handle the error appropriately.
		NSLog(@"ERROR: trying to open camera: %@", error);
	}
    
	[session addInput:input];
    stillImageOutput = [[AVCaptureStillImageOutput alloc] init];
    NSDictionary *outputSettings = [[NSDictionary alloc] initWithObjectsAndKeys: AVVideoCodecJPEG, AVVideoCodecKey, nil];
    [stillImageOutput setOutputSettings:outputSettings];
    
    [session addOutput:stillImageOutput];
	[session startRunning];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)takePictureButton:(id)sender {
    AVCaptureConnection *videoConnection = nil;
	for (AVCaptureConnection *connection in stillImageOutput.connections)
	{
		for (AVCaptureInputPort *port in [connection inputPorts])
		{
			if ([[port mediaType] isEqual:AVMediaTypeVideo] )
			{
				videoConnection = connection;
                [videoConnection setVideoMirrored:YES];
                [videoConnection setVideoOrientation:AVCaptureVideoOrientationLandscapeLeft];
			}
		}
		if (videoConnection) { break; }
	}
    
	NSLog(@"about to request a capture from: %@", stillImageOutput);
    
	[stillImageOutput captureStillImageAsynchronouslyFromConnection:videoConnection completionHandler: ^(CMSampleBufferRef imageSampleBuffer, NSError *error)
     {
		 CFDictionaryRef exifAttachments = CMGetAttachment( imageSampleBuffer, kCGImagePropertyExifDictionary, NULL);
		 if (exifAttachments)
		 {
             // Do something with the attachments.
             NSLog(@"attachements: %@", exifAttachments);
		 }
         else
             NSLog(@"no attachments");
         
         NSData *imageData = [AVCaptureStillImageOutput jpegStillImageNSDataRepresentation:imageSampleBuffer];
         UIImage *image = [[UIImage alloc] initWithData:imageData];
        //rotatedImage = [[UIImage alloc] initWithCGImage:image.CGImage scale:1.0f orientation:UIImageOrientationDownMirrored];
         rotatedImage = image;
         
         UIImageView *imgView = [[UIImageView alloc] initWithFrame:CGRectMake(0, 0, self.vImagePreview.frame.size.width, self.vImagePreview.frame.size.height)];
         [imgView setImage:rotatedImage];
         //[self.vImagePreview addSubview:imgView];
         [self postSigninData];
	 }];
}

- (void) postSigninData {
    NSDateFormatter *dateFormatted = [[NSDateFormatter alloc] init];
    [dateFormatted setDateFormat:@"dd/MM/yyyy"];
    NSString *dateString = [dateFormatted stringFromDate:[NSDate date]];
    NSDateFormatter *timeFormatted = [[NSDateFormatter alloc] init];
    [timeFormatted setDateFormat:@"HH:mm:ss"];
    NSString *timeString = [timeFormatted stringFromDate:[NSDate date]];
    NSDateFormatter *dateFormattedForFilename = [[NSDateFormatter alloc] init];
    [dateFormattedForFilename setDateFormat:@"ddMMyyyy"];
    dateStringForFilename = [dateFormattedForFilename stringFromDate:[NSDate date]];
    NSDateFormatter *timeFormattedForFilename = [[NSDateFormatter alloc] init];
    [timeFormattedForFilename setDateFormat:@"HHmmss"];
    timeStringForFilename = [timeFormattedForFilename stringFromDate:[NSDate date]];
        NSMutableURLRequest *request =
    [[NSMutableURLRequest alloc] initWithURL:
     [NSURL URLWithString:[NSString stringWithFormat:@"%@%@%@", @"https://clockinoutapp.appspot.com/_je/", accountUUID, @"-times"]]];
    [request setHTTPMethod:@"POST"];
    NSData *requestData = [[NSString stringWithFormat:@"%@%@%@%@%@%@%@%@%s", @"_doc={\"Name\" : \"", staffMember.staffName, @"\", \"Signed-in\" : \"", dateString, @" at ", timeString, @"\", \"Image\" : \"", [NSString stringWithFormat:@"%@%@%@%@", staffMember.staffName, dateStringForFilename, timeStringForFilename, @".jpg\""], "}"] dataUsingEncoding:NSUTF8StringEncoding];
    [request setHTTPBody:requestData];
    photoConnection = [[NSURLConnection alloc] initWithRequest:request delegate:self];
}

-(void) uploadImage
    {
        NSData *imageData = UIImageJPEGRepresentation(rotatedImage, 50);
        NSURL *url = [NSURL URLWithString:@"http://heyjimmy.net/uploader/upload.processor.php"];
        ASIFormDataRequest *request = [ASIFormDataRequest requestWithURL:url];
        [request setData:imageData withFileName:[NSString stringWithFormat:@"%@%@%@%@", staffMember.staffName, dateStringForFilename, timeStringForFilename, @".jpg"] andContentType:@"image/jpeg" forKey:@"file"];
        [request setDelegate:self];
        [request startSynchronous];
    }
    
    - (void)requestFinished:(ASIHTTPRequest *)request
    {
        // Use when fetching text data
        NSString *responseString = [request responseString];
        NSLog(@"%@", responseString);
        // Use when fetching binary data
        NSData *responseData = [request responseData];
        [self finishPhoto];
    }

    - (void)requestFailed:(ASIHTTPRequest *)request
    {
        NSError *error = [request error];
    }

- (void) finishPhoto{
    AppDelegate *appDelegate = (AppDelegate *)[[UIApplication sharedApplication] delegate];
    appDelegate.window = [[UIWindow alloc] initWithFrame:[[UIScreen mainScreen] bounds]];
    // Override point for customization after application launch.
    SigninViewController *signinViewController = [[SigninViewController alloc] initWithNibName:@"SigninViewController" bundle:nil];
    signinViewController.accountUUID = accountUUID;
    appDelegate.window.rootViewController = signinViewController;
    [appDelegate.window makeKeyAndVisible];
}

-(AVCaptureDevice *)frontFacingCameraIfAvailable
{
    NSArray *videoDevices = [AVCaptureDevice devicesWithMediaType:AVMediaTypeVideo];
    AVCaptureDevice *captureDevice = nil;
    for (AVCaptureDevice *device in videoDevices)
    {
        if (device.position == AVCaptureDevicePositionFront)
        {
            captureDevice = device;
            break;
        }
    }
    
    //  couldn't find one on the front, so just get the default video device.
    if ( ! captureDevice)
    {
        captureDevice = [AVCaptureDevice defaultDeviceWithMediaType:AVMediaTypeVideo];
    }
    
    return captureDevice;
}

- (void)connection:(NSURLConnection *)connection didReceiveResponse:(NSURLResponse *)response {
    responseData = [[NSMutableData alloc] init];
}

- (void)connection:(NSURLConnection *)connection didReceiveData:(NSData *)data {
    [responseData appendData:data];
}

- (void)connection:(NSURLConnection *)connection didFailWithError:(NSError *)error {
    NSLog(@"Unable to fetch data");
}

- (void)connectionDidFinishLoading:(NSURLConnection *)connection
{
    if (connection == photoConnection){
    NSLog(@"Succeeded! Received %d bytes of data",[responseData
                                                   length]);
    NSString *txt = [[NSString alloc] initWithData:responseData encoding: NSUTF8StringEncoding    ];
    NSLog(txt);
    [self uploadImage];
    }
    if (connection == noticesConnection){
        NSLog(@"Succeeded! Received %d bytes of data",[responseData
                                                       length]);
        NSString *txt = [[NSString alloc] initWithData:responseData encoding: NSUTF8StringEncoding    ];
        NSLog(txt);
        jsonParser = [[SBJsonParser alloc] init];
        NSError *error = nil;
        NSArray *jsonObjects = [jsonParser objectWithString:txt];
        for (int i = 0; i < jsonObjects.count; i++){
            NSMutableDictionary *dictionary = [jsonObjects objectAtIndex:i];
                NSLog(@"Works");
            NSString *text = [NSString stringWithFormat: @"%@%@%@", [dictionary objectForKey:@"Date"], @"\t", [dictionary objectForKey:@"Message"]];
                [noticesArray addObject: text];
            }
        [noticesTableView reloadData];
    }
}


@end