import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { UserinstructorlistComponent } from './userinstructorlist.component';

describe('UserinstructorlistComponent', () => {
  let component: UserinstructorlistComponent;
  let fixture: ComponentFixture<UserinstructorlistComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ UserinstructorlistComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(UserinstructorlistComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
