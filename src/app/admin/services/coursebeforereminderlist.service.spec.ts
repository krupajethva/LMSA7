import { TestBed } from '@angular/core/testing';

import { CoursebeforereminderlistService } from './coursebeforereminderlist.service';

describe('CoursebeforereminderlistService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: CoursebeforereminderlistService = TestBed.get(CoursebeforereminderlistService);
    expect(service).toBeTruthy();
  });
});
