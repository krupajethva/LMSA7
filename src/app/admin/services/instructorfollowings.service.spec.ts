import { TestBed } from '@angular/core/testing';

import { InstructorfollowingsService } from './instructorfollowings.service';

describe('InstructorfollowingsService', () => {
  beforeEach(() => TestBed.configureTestingModule({}));

  it('should be created', () => {
    const service: InstructorfollowingsService = TestBed.get(InstructorfollowingsService);
    expect(service).toBeTruthy();
  });
});
