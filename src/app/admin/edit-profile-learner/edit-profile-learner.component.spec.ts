import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { EditProfileLearnerComponent } from './edit-profile-learner.component';

describe('EditProfileLearnerComponent', () => {
  let component: EditProfileLearnerComponent;
  let fixture: ComponentFixture<EditProfileLearnerComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ EditProfileLearnerComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(EditProfileLearnerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
